<template>
  <component :is="layout">
    <router-view/>
  </component>
</template>
<script>
export default {
  name: 'app',
  computed: {
    layout() {
      return (this.$route.meta.layout || 'DefaultLayout')
    }
  }
}
</script>
