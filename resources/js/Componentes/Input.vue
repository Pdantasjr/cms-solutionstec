<template name="">
    <div class="flex items-center justify-between space-x-1">
        <label class="inline-flex items-center space-x-3" for="password">
            <span
                class="text-sm font-medium leading-4 text-gray-700">
                Senha
                <sup class="font-medium text-danger-700">*</sup>
            </span>
        </label>
    </div>
    <div class="flex items-center space-x-1 group">
        <div class="flex-1">
            <input type="password" id="password" name="title"
                   v-model="form.password"
                   class="block w-full h-10 transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 border-gray-300">
            <div v-if="errors.password" v-text="errors.password"
                 class="text-xs text-red-500 mt-1"></div>
        </div>
    </div>
</template>

<script>
import {defineComponent, reactive} from 'vue'

export default defineComponent({
    props: {
        errors: Object
    },
    data() {
        return {
            form: this.$inertia.form({
                name: null,
                email: null,
                password: null,
            }),
        }
    }
})
</script>
