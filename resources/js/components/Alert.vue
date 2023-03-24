<template>
    <div :class="tipo" role="alert">
        {{ mensagem }}
    </div>
</template>

<script>
    export default {
        props: [
            'tipo',
            'mensagem'
        ],
        mounted() {
            console.log('Alerta montado.')
        }
    }
</script>
