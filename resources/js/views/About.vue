<template>
  <div class="content">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-6">
          <h1 v-text="$ml.get('about.title')"></h1>
          <div class="" v-html="$ml.get('about.text')"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'sobre'
}
</script>

<style lang="css">
</style>
