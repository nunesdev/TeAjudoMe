<template>
  <div class="content">

    <div class="">

        <div class="row">
          <div class="col-12">
            <AddStore></AddStore>
          </div>
        </div>
    </div>
  </div>
</template>

<script> 
import AddStore from "@components/Movimento/Forms/AddStore"
import EventBus from '@src/event-bus';

export default {
  components: {
    AddStore
  },
  created() {
    EventBus.$emit('OPEN_SIDEBAR', false);
  }
}
</script>

<style lang="css">
</style>
