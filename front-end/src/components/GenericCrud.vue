<template>
    <div>
        <v-row>
            <v-col cols="12">
                <h1 class="text-h4 font-weight-bold mb-6">
                    {{ title }}
                </h1>
            </v-col>
        </v-row>

        <v-card elevation="2">
            <v-container>
                <v-card-title>
                    <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        :label="searchLabel"
                        single-line
                        hide-details
                        width="50vh"
                        class="mr-4"
                    ></v-text-field>
                    
                    <v-btn
                        class="mt-2"
                        color="primary"
                        @click="showAddDialog = true"
                    >
                        {{ addButtonText }}
                    </v-btn>
                </v-card-title>
            </v-container>

            <v-data-table
                :headers="headers"
                :items="items"
                :search="search"
                :loading="loading"
                class="elevation-1"
            >
                <template v-for="(template, key) in customTemplates" :key="key" #[key]="props">
                    <component :is="template" v-bind="props" />
                </template>
                
                <template #item.actions="{ item }">
                    <div class="ma-2">
                        <v-icon color="primary" @click="editItem(item)">mdi-pencil</v-icon>
                        <v-icon color="error" @click="deleteItem(item)">mdi-delete</v-icon>
                    </div>
                </template>
            </v-data-table>
        </v-card>

        <v-dialog v-model="showAddDialog" max-width="500px">
            <v-card>
                <v-card-title>
                    {{ editingItem ? editDialogTitle : addDialogTitle }}
                </v-card-title>
                <v-card-text>
                    <slot name="form" :form="form" :editing="!!editingItem"></slot>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="grey darken-1"
                        text
                        @click="closeDialog"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        color="primary"
                        @click="saveItem"
                    >
                        Salvar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue'

export interface CrudHeader {
    text: string
    value: string
    sortable?: boolean
}

export default defineComponent({
    name: 'GenericCrud',
    props: {
        title: {
            type: String,
            required: true
        },
        searchLabel: {
            type: String,
            default: 'Buscar'
        },
        addButtonText: {
            type: String,
            default: 'Adicionar'
        },
        addDialogTitle: {
            type: String,
            default: 'Adicionar'
        },
        editDialogTitle: {
            type: String,
            default: 'Editar'
        },
        headers: {
            type: Array as PropType<CrudHeader[]>,
            required: true
        },
        items: {
            type: Array,
            required: true
        },
        loading: {
            type: Boolean,
            default: false
        },
        form: {
            type: Object,
            required: true
        },
        customTemplates: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            search: '',
            showAddDialog: false,
            editingItem: null as any
        }
    },
    methods: {
        editItem(item: any) {
            this.editingItem = item
            this.$emit('edit', item)
            this.showAddDialog = true
        },
        deleteItem(item: any) {
            this.$emit('delete', item)
        },
        saveItem() {
            this.$emit('save', this.form)
            this.closeDialog()
        },
        closeDialog() {
            this.showAddDialog = false
            this.editingItem = null
            this.$emit('close-dialog')
        }
    }
})
</script> 