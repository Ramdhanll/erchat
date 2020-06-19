<template>
  <div class="chat-app">
    <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage" />
    <ContactsList :contacts="contacts" @selected="startConversationWith"/>
  </div>
</template>

<script>
import Conversation from './Conversation'
import ContactsList from './ContactsList'
export default {
  props: ['user'],
  components: {
    Conversation,ContactsList
  },
  data() {
    return {
      selectedContact : null,
      messages: [],
      contacts: []
    }
  },
  methods: {
    startConversationWith(contact) {
      axios.get(`/conversation/${contact.id}`)
        .then((response) => {
          this.messages = response.data;
          this.selectedContact = contact;
        })
    },
    saveNewMessage(text) {
      this.messages.push(text);
    },
    handleIncoming(message) {
      console.log(message);
      if (this.selectedContact && message.from == this.selectedContact.id) {
        this.saveNewMessage(message);
        return;
      }

    }
  },
  mounted() {
    Echo.private(`messages.${this.user.id}`)
        .listen('newMessage', (e) => {  // terdapat 2 arguman, argumen pertama event yang ingin digunakan
          this.handleIncoming(e.message);
        })
    



    axios.get('/contacts')
      .then((response) => {
        this.contacts = response.data;
      })
  },
}
</script>

<style scoped>
  .chat-app {
    display: flex;
  }
</style>>
