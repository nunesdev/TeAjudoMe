<template>
  <div class="content">

    <div class="">

        <div class="row">
          <div class="col-12">
            <AddVoluntario></AddVoluntario>
          </div>
        </div>
    </div>
  </div>
</template>

<script>
import AddVoluntario from "@components/Movimento/Forms/AddVoluntario"
import EventBus from '@src/event-bus';

export default {
  components: {
    AddVoluntario
  },
  created() {
    EventBus.$emit('OPEN_SIDEBAR', false);
  }
}
</script>

<style lang="css">
</style>
