<template>
    <div class="matrix">
        <div class="card">
            <div class="card-header bg-success text-white">{{ cardTitle }} ({{dimensionsPrint}})</div>
            <table class="table table-bordered">
                <tbody>
                <tr v-for="row in matrix">
                    <td class="matrix-cell" v-for="item in row">{{ item }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            required: true
        },
        matrix: {
            type: Array,
            required: true
        },
    },
    computed: {
        cardTitle() {
            return _.startCase(this.name);
        },
        dimensionsPrint() {
            let rows = this.matrix.length;
            let cols = this.matrix[0].length || 0;

            return `${rows}x${cols}`;
        }
    },
}
</script>

<style>
</style>
