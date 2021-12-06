<template>
  <div class="conversation">
    <h1>{{ contact ? contact.name : "Select Contact" }}</h1>
    <MessageFeed :contact="contact" :messages="messages" />
    <MessageComposer v-if="contact" @send="sendMessage" @sendImage="sendMediaMessage" />
  </div>
</template>
<script>
import MessageFeed from "./MessageFeed";
import MessageComposer from "./MessageComposer";
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
  components: { MessageFeed, MessageComposer },
};
</script>
<style lang="scss" scoped>
.conversation {
  flex: 5;
  display: flex;
  flex-direction: column;
  justify-content: space-between;

  h1 {
    font-size: 20px;
    padding: 10px;
    margin: 0;
    border-bottom: 1px dashed lightgray;
  }
}
</style>
