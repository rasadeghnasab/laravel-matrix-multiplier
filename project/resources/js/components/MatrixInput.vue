<template>
    <div class="matrix">
        <div class="card">
            <div class="card-header bg-primary text-white">{{ cardTitle }} ({{dimensionsPrint}})</div>
            <div class="card-body dimension-controller">
                <div class="row d-flex align-content-start d-inline-flex">
                    <div class="flex-column">
                        <h5>Rows</h5>
                        <input type="number" min="1" max="10" v-model="dimensions.rows">
                    </div>
                    <div class="flex-column">
                        <h5>Cols</h5>
                        <input type="number" min="1" max="10" v-model="dimensions.cols">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <button class="btn btn-primary" v-on:click="fillWith(() => { return 0; })">0</button>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" v-on:click="fillWith(() => { return 1; })">1</button>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary"
                                v-on:click="fillWith(() => { return Math.floor(Math.random() * 20); })">Random
                        </button>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" v-on:click="fillWith(() => '')">Clear</button>
                    </div>
                </div>
            </div>
            <table class="table">
                <tbody>
                <tr v-for="(row, rowIndex) in matrix">
                    <td class="matrix-cell" v-for="(col, colIndex) in row">
                        <input :type="type" v-model="matrix[rowIndex][colIndex]"
                               :maxlength="maxlength"
                        >
                    </td>
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
        type: {
            type: String,
            default: 'number',
            validator: value => _.indexOf(['number', 'text'], value) !== -1
        },
        maxlength: {
            type: Number,
            default: 3,
            validator: value => value <= 6
        },
    },
    created() {
        this.calculateMatrix();
    },
    data: () => {
        return {
            dimensions: {
                rows: 3,
                cols: 3,
            },
            matrix: []
        }
    },
    methods: {
        getMatrixItem(i, j) {
            return typeof this.matrix[i] !== 'undefined' ? (this.matrix[i][j] || this.cellDefaultValue) : this.cellDefaultValue;
        },
        calculateMatrix(callback) {
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
        fillWith(callback) {
            this.calculateMatrix(callback);
        },
    },
    computed: {
        cardTitle() {
            return _.startCase(this.name);
        },
        cellDefaultValue() {
            return '';
        },
        dimensionsPrint() {
            return `${this.dimensions.rows}x${this.dimensions.cols}`;
        }

    },
    watch: {
        matrix() {
            this.$emit('matricesUpdated', _.snakeCase(this.name), this.matrix);
        },
        dimensions: {
            handler() {
                this.calculateMatrix();
            },
            deep: true
        }
    }
}
</script>

<style>

.matrix-cell input {
    min-width: 40px;
    max-width: 40px;
    min-height: 40px;
    max-height: 40px;
}

/* Chrome, Safari, Edge, Opera */
.matrix-cell input::-webkit-outer-spin-button,
.matrix-cell input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
.matrix-cell input[type=number] {
    -moz-appearance: textfield;
}

.dimension-controller input {
    max-width: 80px;
    max-height: 50px;
    font-size: 18px;
}

.dimension-controller > .row > div {
    padding: 0 10px;
}
</style>
