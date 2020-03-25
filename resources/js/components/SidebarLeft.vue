<template>
  <div class="sidebar--left" :class="{active: active}">
    <div class="sidebar--left__close" @click="isActive = false">
      <span class="icon-circle-left"></span>
    </div>
  </div>
</template>

<script>
export default {
  props: ['active'],
  data() {
    return {
      isActive : this.active ? true : false,
    }
  }
}
</script>

<style lang="sass">
  .sidebar--left
    position: fixed
    top: 0
    width: 80%
    height: 100%
    left: -80%
    z-index: 10
    background: white
    transition: left .2s linear
    &.active
      left: 0
    &__close
      position: absolute
      color: #146b79
      font-size: 2em
      right: 10px
      top: 10px
</style>
