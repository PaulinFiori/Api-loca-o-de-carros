<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                            <div class="alert alert-success" role="alert" v-text="stats">
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'status'
        ],
        data() {
            return {
                stats: this.status
            }
        },
        methods: {
        },
        mounted() {
            console.log('Tela home montado.')
        }
    }
</script>