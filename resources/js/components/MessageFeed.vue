<template>
  <div class="feed" ref="feed">
    <ul v-if="contact">
      <li v-for="message in messages" :key="message.id" :class="`message${message.to == contact.id ? ' sent' : ' received'}`">
        <div class="text">
          {{ message.text }}
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {  
  props : ['contact', 'messages'],
  methods: {
    scrollToBottom() {
      setTimeout(() => {
        this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;

      }, 50)
    }
  },
  watch: {
    contact(contact) {
      this.scrollToBottom();
    },
    messages(messages) {
      this.scrollToBottom();
    }
  },
}
</script>

<style lang="scss" scoped>
  .feed {
    background: #f0f0f0;
    height: 100%;
    max-height: 470px;
    overflow: scroll;

    ul {
      list-style-type: none;
      padding: 5px;

      li {
        &.message { 
          margin: 10px 0;
          widows: 100%;

          .text {
            max-width: 200px;
            border-radius: 5px;
            padding: 12px;
            display: inline-block;
          }

          &.received {
            text-align: right;

            .text {
              background-color: #b2b2b2;
            }
          }

          &.sent {
            text-align: left;

            .text {
              background-color: #81c4f9;
            }
          }
        }
      }
    }
  }
</style>