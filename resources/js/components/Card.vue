<template>
    <div class="col-md-8 mb-3">
        <div class="card">
            <div class="card-header">{{ titulo }}</div>
            <div class="card-body">
                <slot name="conteudo"></slot>
            </div>
            <div class="card-footer">
                <slot name="rodape"></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'titulo'
        ],
        mounted() {
            console.log('Card montado.')
        }
    }
</script>
