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
      this.updateUnreadCount(contact, true);

      axios.get(`/conversation/${contact.id}`)
        .then((response) => {
          this.messages = response.data;
          this.selectedContact = contact;
        })
    },
    saveNewMessage(message) {
      this.messages.push(message);
    },
    handleIncoming(message) {
      if (this.selectedContact && message.from == this.selectedContact.id) {
        this.saveNewMessage(message);
        return;
      }

      this.updateUnreadCount(message.from_contact, false);
    },
    updateUnreadCount(contact, reset) {
      this.contacts = this.contacts.map((single) => {
        if (single.id !== contact.id) {
          return single;
        }

        if (reset) 
          single.unread = 0;
        else 
          single.unread += 1;
        
        return single;
      })
    }
  },
  mounted() {
    Echo.private(`messages.${this.user.id}`) // nama channel
        .listen('newMessage', (e) => {  // terdapat 2 arguman, argumen pertama event yang ingin digunakan kedua function
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
