<template>
    <web-layout>

        <o-modal v-model:active="confirmDeleteActive">
            <p class="p-4 text-black">Are you sure you want to delete the record?</p>

            <div class="flex flex-row-reverse gap-2 bg-gray-100 p-3">
                <o-button variant="danger" @click="remove">Delete</o-button>
                <o-button @click="confirmDeleteActive = false">Cancel</o-button>
            </div>
        </o-modal>

        <div class="mycard">
            <div class="mycard-body">
                <h3>App To Do</h3>

                <Button @click="removeAll">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="#F00" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    Delete All
                </Button>

                <form @submit.prevent="create" class="flex gap-2 mt-2">
                    <Input :class="{ 'text-red-400 bg-red-200': (errors.name && todoSelected == 0) }"
                        v-model="form.name" placeholder="Create To Do"></Input>
                    <Button>Send</Button>
                </form>

                <InputError v-if="todoSelected == 0" :message="errors.name" />

                <!--  <draggable v-model="myArray" item-key='element'>
                    <template #item="{ element }">
                        <div>{{ element }}</div>
                        </template>
                     </draggable>-->


                <ul id="listToDo">
                    <draggable v-model="dtodos" item-key="id" @end="order">
                        <template #item="{ element }">
                            <li :data-id="element.id" class="border py-3 px-4 mt-2 flex flex-row">
                                <!--  <li v-for="t in todos" class="border py-3 px-4 mt-2" :key="t">-->

                                <svg  @click="status(element)" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    :stroke="element.status == '1' ? '#0F0' : '#000'" viewBox="0 0 24 24"
                                    stroke-width="1.5" class="mt-3 size-4 inline mr-1">


                                    <path v-if="element.status == '1'" stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />

                                    <path v-else stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />

                                </svg>

                                <span class="w-full pt-2 pl-2" v-show="!element.editMode" @click="element.editMode = true">{{ element.name
                                    }}</span>
                                <InputError v-if="todoSelected == element.id" :message="errors.name" />
                                <Input v-show="element.editMode == true" v-model="element.name"
                                    @keyup.enter="update(element)" />
                                <button class="float-right"
                                    @click="confirmDeleteActive = true; deleteTodoRow = element.id">

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="h-6 w-6" fill="#F00">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>


                                </button>
                            </li>
                        </template>
                    </draggable>
                </ul>

            </div>
        </div>

    </web-layout>
</template>
<script>

import { router } from '@inertiajs/vue3';

import draggable from 'vuedraggable'

import { Button } from '@/components/ui/button';
import Input from '@/components/ui/input/Input.vue';
import WebLayout from '@/layouts/WebLayout.vue';
import InputError from '@/components/InputError.vue';

export default {
    components: {
        WebLayout,
        Button,
        Input,
        InputError,
        draggable
    },
    props: {
        errors: Object,
        todos: Array
    },
    data() {
        return {
            myArray: ['uno', 'dos', 'tres', 'cuatro'],
            form: {
                name: ''
            },
            todoSelected: 0,
            confirmDeleteActive: false,
            deleteTodoRow: '',
            dtodos: this.todos
        }
    },

    methods: {
        create() {
            this.todoSelected = 0
            router.post(route('todo.store'), {
                name: this.form.name
            }, {
                onSuccess: (page) => {
                    // console.log(page)
                    console.log(page.props.todos)
                    this.dtodos = page.props.todos
                    // setTimeout(() => window.location.reload(), 500)

                },
            })

        },
        update(todo) {
            this.todoSelected = todo.id
            todo.editMode = false
            router.put(route('todo.update', todo.id), {
                name: todo.name
            })
        },
        remove() {
            this.confirmDeleteActive = false
            router.delete(route('todo.destroy', this.deleteTodoRow), {
                preserveScroll: true
                ,
                onSuccess: (page) => {
                    // console.log(page)
                    console.log(page.props.todos)
                    this.dtodos = page.props.todos
                    // setTimeout(() => window.location.reload(), 500)

                },

            })
        },
        removeAll() {
            router.delete(route('todo.destroy'))
        },
        status(todo) {
            todo.status = !todo.status
            router.post(route('todo.status', todo.id), {
                status: todo.status
            })
        },
        order() {
            // let ids = ''
            let ids = []
            document.querySelectorAll("#listToDo li").forEach((li) => {
                // ids += li.getAttribute('data-id') + ','
                ids.push(li.getAttribute('data-id'))
            })
            // console.log(ids.slice(0, -1))
            router.post(route('todo.order'), {
                ids: ids
            })
        }
    },
}
</script>