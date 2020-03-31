<template>
    <div class="">
      <div class="sidebar--third" :class="{active:isActiveSidebarMember}">
        <div class="sidebar--close" @click="changeStateMember">
          <span class="icon-circle-left"></span>
        </div>

        <div class="sidebar--third__body">
          <AddMember :address.async="address" @closeSidebar="closeSidebar" />
        </div>
      </div>
    </div>
</template>

<script>
import AddStore from './AddStore'

export default {
  components: {
    AddStore
  }
}
</script>

<style lang="css">
</style>
