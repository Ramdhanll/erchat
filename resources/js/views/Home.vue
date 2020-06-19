<template>
  <div class="container mt-3">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Erchat Room</div>
          <div class="card-body">
            <ChatApp :user="user"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ChatApp from '../components/ChatApp'
export default {
  props: {
    user: {
      type: Object,
      default : []
    }
  },
  components: {ChatApp}
}
</script>

<style>

</style>