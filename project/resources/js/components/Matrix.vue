<template>
    <div class="matrix">
        <div class="card">
            <div class="card-header bg-success text-white">{{ cardTitle }} ({{dimensions}})</div>
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
    methods: {
        draw(callback) {
            let matrix = [];
            for (let i = 0; i < this.dimensions.rows; i++) {
                let row = [];
                for (let j = 0; j < this.dimensions.cols; j++) {
                    row[j] = typeof callback !== 'undefined' ?
                        callback(this.getMatrixItem(i, j)) : this.getMatrixItem(i, j);
                }
                matrix[i] = row;
            }

            this.matrix = matrix;
        },
    },
    computed: {
        cardTitle() {
            return _.startCase(this.name);
        },
        dimensions() {
            let rows = this.matrix.length;
            let cols = this.matrix[0].length || 0;

            return `${rows}x${cols}`;
        }
    },
    watch: {}
}
</script>

<style>
</style>
