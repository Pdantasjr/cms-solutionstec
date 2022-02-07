<template>
    <div class="flex items-center justify-between space-x-1">
        <label class="inline-flex items-center space-x-3" for="name">
            <span class="text-sm font-medium leading-4 text-gray-700">
                {{ title }}
                <sup class="font-medium text-danger-700">*</sup>
            </span>
        </label>
    </div>
    <div class="flex items-center space-x-1 group">
        <div class="flex-1">
            <input :type="type"
                   :id="id"
                   :name="name"
                   class="block w-full h-10 transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 border-gray-300">
            <div v-if="errors.name" v-text="errors.name"
                 class="text-xs text-red-500 mt-1"></div>
        </div>
    </div>
</template>

<script>
import {defineComponent, reactive} from 'vue'

export default defineComponent({
    name: "Input Component",
    props: {
        type: String,
        name: String,
        id: String,
        title: String,
        errors: Object,
    },
})
</script>
