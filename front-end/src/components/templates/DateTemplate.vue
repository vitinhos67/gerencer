<template>
    {{ item.created_at ? new Date(item.created_at).toLocaleDateString('pt-BR') : '-' }}
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    name: 'DateTemplate',
    // eslint-disable-next-line vue/require-default-prop
    props: {
        item: {
            type: Object,
            required: true
        }
    }
})
</script> 