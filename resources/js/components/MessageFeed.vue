<template>
  <div class="feed" ref="feed" id="message_feed">
    <ul v-if="contact" style="max-width: 600px; width: 100%">
      <li
        v-for="message in messages"
        :class="`message ${
          message.to == contact.id ? ' msg_card_sent ' : ' msg_card_received '
        }`"
        :key="message.id"
      >
        <div v-if="message.type == 'text'" class="text box">
          {{ message.text }}
        </div>
        <div v-else-if="message.type == 'image'">
          <img
            class="round_c_s"
            :src="$siteURL + `/images/message/thumb/` + message.text"
            alt=""
          />
        </div>
      </li>
    </ul>
  </div>
</template>
<script>
import EventBus from "../eventBus";
export default {
  props: {
    contact: {
      type: Object,
      required: true,
    },
    messages: {
      type: Array,
      required: true,
    },
  },

  methods: {
    scrollToBottom() {
      setTimeout(() => {
        this.$refs.feed.scrollTop =
          this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
      }, 100);
    },
  },
  watch: {
    contact(contact) {
      this.scrollToBottom();
    },
    message(messages) {
      this.scrollToBottom();
    },
  },
  mounted() {
    EventBus.$on("message", (data) => {
      this.scrollToBottom();
    });
  },
};
</script>
<style lang="scss" scoped>
.feed {
  background: var(--gray-very-light);
  height: 100%;
  display: flex;
  justify-content: center;
  overflow: auto;

  ul {
    list-style-type: none;
    padding: 5px;

    li {
      &.message {
        margin: 10px 0;
        width: 100%;

        .text {
          max-width: 200px;
          border-radius: 5px;
          padding: 12px;
          display: inline-block;
        }
      }
      &.received {
        text-align: left;

        .text {
          background: #b2b2b2;
        }
      }
      &.sent {
        text-align: right;

        .text {
          background: #b2b2b2;
        }
      }
    }
  }
}
</style>
