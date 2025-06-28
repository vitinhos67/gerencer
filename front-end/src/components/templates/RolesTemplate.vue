<template>
    <div v-if="item.roles && item.roles.length > 0">
        <v-chip
            v-for="role in item.roles"
            :key="role.id"
            color="primary"
            small
            class="mr-1 mb-1"
        >
            {{ role.name }}
        </v-chip>
    </div>
    <span v-else>-</span>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    name: 'RolesTemplate',
    // eslint-disable-next-line vue/require-default-prop
    props: {
        item: {
            type: Object,
            required: true
        }
    }
})
</script> 