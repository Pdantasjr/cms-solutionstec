<template>
    <div class="absolute flex max-w-xs w-full mt-4 mr-4 top-3 right-0 bg-white border border-gray-300 rounded-lg shadow-2xl p-4 z-20">
        <div class="mr-2">
            <svg class="w-6 text-green-600 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="flex-1 text-gray-800">
            Paciente cadastrado,0
        </div>
        <div class="ml-2">
            <button class="align-top text-gray-500 hover:text-gray-700 focus:outline-none focus:text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "Toast"
}
</script>

<style scoped>

</style>
