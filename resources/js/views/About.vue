<template>
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-12">
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
