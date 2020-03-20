<template>
  <div class="">
    <div class="sidebar">
      <div class="sidebar-logo text-center">
        <img src="/images/teajudome.png" width="128" height="128" alt="">
      </div>
      <div class="sidebar-volunteers-count text-center">
        <div class="row justify-content-center">
          <div class="col-12">
            20 <small>voluntários cadastrados</small>
          </div>
          <div class="col-12">
            <div @click="changeState" class="btn btn-handup">Posso ajudar
              <span class="icon-hand-stop"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="sidebar--secondary" :class="{active:isActive}">
      <div class="sidebar--close" @click="changeState">
        <span class="icon-circle-left"></span>
      </div>

      <div class="sidebar--secondary__body">
        <AddVoluntario :address.async="address" @closeSidebar="closeSidebar" />
      </div>
    </div>

  </div>
</template>

<script>
 import AddVoluntario from '@components/AddVoluntario';

export default {
  props: ['address'],
  name: 'Sidebar',
  components: {
    AddVoluntario
  },
  data() {
    return {
      isActive: true
    }
  },
  methods: {
    changeState() {
      this.isActive = !this.isActive
      this.$emit('sidebarOpen', this.isActive);
    },
    closeSidebar(v) {
      this.isActive = v;
      this.$emit('sidebarOpen', this.isActive);
    },
  }
}
</script>

<style lang="css">
</style>
