<template>
  <div class="conversation">
    <h1>{{ contact ? contact.name : 'Select a Contact' }}</h1>
    <MessageFeed :contact="contact" :messages="messages" />
    <MessageComposer @send="sendMessage" />
  </div>
</template>

<script>
import MessageFeed from './MessageFeed'
import MessageComposer from './MessageComposer'
export default {
  components: {
    MessageComposer, MessageFeed
  },
  props: ['contact','messages'],
  methods: {
    sendMessage(text) {
      if (!this.contact) {
        return;
      }

      axios.post('/conversation/send', {
        contact_id : this.contact.id,
        text : text
      }).then(response => {
        this.$emit('new', response.data);
      })
      
    }
  },
}
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
      border-bottom: 1px dashed lightgrey;
    }
  }
</style>