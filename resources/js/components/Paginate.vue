<template>
    <div class="container">
        <nav aria-label="Paginação">
            <ul class="pagination" style="cursor: pointer;">
                <slot></slot>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        props: [
        ],
        mounted() {
            console.log('Paginate montado.')
        }
    }
</script>
