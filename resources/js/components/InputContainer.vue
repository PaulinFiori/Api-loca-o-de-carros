<template>
    <div class="form-group mb-3">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: [
        ],
        mounted() {
            console.log('Input Montado.')
        }
    }
</script>
