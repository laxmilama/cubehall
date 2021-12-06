<template>
  <div class="conversation">
    <div class="cHead_">
      <div v-if="contact" class="flex-box">
        <button @click="back" class="msg_back_btn">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-chevron-left"
          >
            <polyline points="15 18 9 12 15 6"></polyline>
          </svg>
        </button>
        <a :href="$siteURL + '/@' + contact.slug">
          <div class="flex-box">
            <div class="msg_user_profile round_full">
              <img :src="$siteURL + '/images/profile/thumb/' + contact.profile_image" />
            </div>
            <div>
              <span>
                {{ contact.name }}
              </span>
              <div>
                <span class="c_handle">
                  {{ "@" + contact.slug }}
                </span>
              </div>
            </div>
          </div>
        </a>
      </div>
      <div v-else>Select Contact</div>
    </div>
    <MessageFeed v-show="contact" :contact="contact" :messages="messages" />
    <MessageComposer v-show="contact" @send="sendMessage" @sendImage="sendMediaMessage" />
    <MessageEmpty v-if="!contact"></MessageEmpty>
  </div>
</template>
<script>
import MessageFeed from "./MessageFeed";
import MessageComposer from "./MessageComposer";
import MessageEmpty from "./MessageEmpty.vue";
import EventBus from "../eventBus";
export default {
  props: {
    contact: {
      type: Object,
      default: null,
    },
    messages: {
      type: Array,
      default: () => [],
    },
  },
  methods: {
    back() {
      EventBus.$emit("deselectcontact", true);
    },
    sendMessage(text) {
      if (!this.contact) {
        return;
      }
      axios
        .post("/conversation/send", {
          contact_id: this.contact.id,
          text: text,
          type: "text",
        })
        .then((response) => {
          this.$emit("new", response.data);
          // send message imition to scroll
          EventBus.$emit("message", true);
        });
    },
    sendMediaMessage(text) {
      if (!this.contact) {
        return;
      }
      axios
        .post("/conversation/send", {
          contact_id: this.contact.id,
          text: text,
          type: "image",
        })
        .then((response) => {
          this.$emit("new", response.data);
          // send message imition to scroll
          EventBus.$emit("message", true);
        });
    },
  },
  components: { MessageFeed, MessageComposer, MessageEmpty },
};
</script>
