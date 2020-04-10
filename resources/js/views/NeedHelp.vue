<template>
  <div class="content">

    <div class="">

        <div class="row">
          <div class="col-12">
            <AddMember></AddMember>
          </div>
        </div>
    </div>
  </div>
</template>

<script>
import AddMember from "@components/Adds/AddMember"
import EventBus from '@src/event-bus';
export default {
  components: {
    AddMember
  },
  created() {
    EventBus.$emit('OPEN_SIDEBAR_HOME', false);
  }
}
</script>

<style lang="css">
</style>
