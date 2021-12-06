<template>
  <div class="contacts-list">
    <div class="_MBL-addPad">
      <h2>Message</h2>
    </div>
    <ul>
      <li
        v-for="contact in sortedContacts"
        :key="contact.id"
        @click="selectContact(contact)"
        :class="{ c_selected: contact == selected }"
        class="msg_user round_c_s"
      >
        <div class="msg_user_profile round_full">
          <img :src="$siteURL + '/images/profile/thumb/' + contact.profile_image" />
        </div>
        <div class="contact">
          <div>
            <strong>{{ contact.name }}</strong>
          </div>
          <span class="contact_msg_short">
            {{ truncateMsg(contact.recent.text) }}
          </span>
        </div>
        <span class="unread" v-if="contact.unread">{{ contact.unread }}</span>
      </li>
    </ul>
  </div>
</template>
<script>
export default {
  props: {
    contacts: {
      type: Array,
      default: [],
    },
  },
  data() {
    return {
      selected: this.contacts.length ? this.contacts[0] : null,
    };
  },
  methods: {
    selectContact(contact) {
      this.selected = contact;

      this.$emit("selected", contact);
      // console.log(this.$emit('selected',contact));
    },
    truncateMsg(string) {
      var n = string;
      if (string.length > 40) {
        n = string.substring(0, 40) + "...";
      }
      return n;
    },
  },
  computed: {
    sortedContacts() {
      return _.sortBy(this.contacts, [
        (contact) => {
          // if (contact == this.selected) {
          //   // return;
          // }
          // return contact.unread;
        },
      ]);
    },
  },
};
</script>
<style lang="scss" scoped>
.contacts-list {
  max-width: 375px;
  width: 100%;

  ul {
    list-style-type: none;
    padding-left: 0;
  }
}
</style>
