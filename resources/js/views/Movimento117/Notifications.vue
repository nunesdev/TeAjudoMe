<template>
  <div class="content">

    <div class="">
        <Notifications />
    </div>
  </div>
</template>

<script>
import AddMember from "@components/Movimento/Forms/AddMember"
import EventBus from '@src/event-bus';

import Notifications from '@components/Movimento/Notifications'

export default {
  components: {
    Notifications
  },
}
</script>

<style lang="css">
</style>
