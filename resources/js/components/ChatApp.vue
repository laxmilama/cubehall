<template>
  <div class="_chat">
    <ContactList
      :class="{ fullcontact: contactIsActive }"
      :contacts="contacts"
      @selected="startConversationWith"
    />
    <Conversation
      :class="{ fullmsgfeed: !contactIsActive }"
      :contact="selectedContact"
      :messages="messages"
      @new="saveNewMessage"
    />
  </div>
</template>
<script>
import Conversation from "./Conversation";
import ContactList from "./ContactList";
import EventBus from "../eventBus";
import { constant } from "lodash";
export default {
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      selectedContact: null,
      messages: [],
      contacts: [],
      cD: null,
      canLoadMore: true,
      newmessages: [],
      page: 1,
      data: null,
      contact: null,
    };
  },
  mounted() {
    Echo.private(`messages.${this.user.id}`).listen("newMessage", (e) => {
      this.handleIncoming(e.message);
    });
    // console.log(this.user);
    axios.get("/contacts").then((response) => {
      //   this.contacts = response.data;
      this.cD = response.data;
      Object.values(response.data.data).forEach((e) => {
        this.contacts.push(e);
      });
      // console.log(this.contacts);
    });

    const msgElm = document.querySelector("#message_feed");

    msgElm.addEventListener("scroll", (e) => {
      const fc = msgElm.firstElementChild.firstElementChild;
      if (msgElm.scrollTop == 0) {
        if (this.canLoadMore) {
          this.loadMore();
          var topPos = fc.offsetTop;
          msgElm.scrollTop = topPos;
          return;
        }
      }
    });

    EventBus.$on("deselectcontact", (data) => {
      console.log("what");
      this.deselectContact();
    });
  },

  methods: {
    startConversationWith(contact) {
      this.contact = contact;
      this.updateUnreadCount(contact, true);
      axios.get(`/conversation/${contact.id}`).then((response) => {
        this.data = response.data;
        this.messages = [];
        if (this.data.current_page == this.data.last_page) {
          this.canLoadMore = false;
        } else {
          this.canLoadMore = true;
        }
        Object.values(response.data.data).forEach((e) => {
          this.messages.unshift(e);
        });

        this.selectedContact = contact;
      });
    },
    deselectContact() {
      this.selectedContact = null;
      this.contact = null;
    },
    loadMore() {
      if (this.data) {
        if (this.data.current_page < this.data.last_page) {
          this.page = this.data.current_page + 1;
        } else {
          this.canLoadMore = false;
          return true;
        }
      } else {
        this.page = 1;
      }

      axios.get(`/conversation/${this.contact.id}?page=` + this.page).then((response) => {
        this.data = response.data;
        if (this.data.current_page == this.data.last_page) {
          this.canLoadMore = false;
        }
        // this.messages = response.data;
        Object.values(response.data.data).forEach((e) => {
          this.messages.unshift(e);
        });
      });
    },
    saveNewMessage(message) {
      this.messages.push(message);
    },
    handleIncoming(message) {
      if (this.selectedContact && message.from == this.selectedContact.id) {
        this.saveNewMessage(message);
        EventBus.$emit("message", true);
        return;
      }
      this.updateUnreadCount(message.from_contact, false);
    },
    updateUnreadCount(contact, reset) {
      this.contacts = this.contacts.map((single) => {
        if (single.id != contact.id) {
          return single;
        }
        if (reset) single.unread = 0;
        else single.unread += 1;

        return single;
      });
    },
  },
  components: { Conversation, ContactList },
  computed: {
    contactIsActive: function () {
      if (this.contact) {
        return false;
      } else {
        return true;
      }
    },
  },
};
</script>
