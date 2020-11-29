<template>
    <div class="matrix-multiplication">
        <div class="mt-5 container-lg container-md loading-container">
            <div class="row">
                <h1>Matrix Multiplier</h1>
            </div>
            <div class="row">
                <div class="col-sm col-md mb-2 p-0">
                    <MatrixInput v-on:matricesUpdated="updateMatrices" name="first matrix"></MatrixInput>
                </div>
                <div class="col-sm col-md mb-2 p-0">
                    <MatrixInput v-on:matricesUpdated="updateMatrices" name="second_matrix"></MatrixInput>
                </div>
            </div>
            <div class="row">
                <button v-on:click="calculate" class="btn btn-primary btn-block">Multiply Matrices</button>
            </div>
            <div class="row mt-5">
                <div v-if="errorBag.length" class="col-md-6 col-sm-12">
                    <div v-for="error in errorBag" class="alert alert-danger alert-dismissible fade show">
                        {{ error }}
                    </div>
                </div>
                <div v-if="resultMatrix.length" class="col-md-6 col-sm-12">
                    <Matrix :matrix="resultMatrix" name="result matrix"/>
                </div>
            </div>
            <div v-if="loading" class="loading-modal w-100 h-100 d-flex justify-content-center align-items-center">
                <div class="spinner-border text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MatrixInput from '../components/MatrixInput';
import Matrix from "../components/Matrix";

export default {
    components: {
        MatrixInput,
        Matrix,
    },
    data() {
        return {
            matrices: {},
            columnSize: 6,
            resultMatrix: [],
            errorBag: [],
            loading: false,
        }
    },
    methods: {
        updateMatrices(name, value) {
            this.matrices[name] = value;
        },
        validate() {
            // Note: I don't a write front-end validator,
            // so that you can fill free to send non-validated requests to the server
        },
        async calculate() {
            if (this.loading) {
                return false;
            }

            this.errorBag = this.resultMatrix = [];
            let data = this.matrices;

            // copy `vue instance` in order to have access to it in the axios
            let vi = this;
            this.loading = true;

            // Note: I put this setTimeout here to simulate the network latency.
            setTimeout(async () => {
                await axios
                    .post('/matrix/multiply', data)
                    .then(({data}) => {
                        vi.resultMatrix = data.data
                    })
                    .catch(({response}) => {
                        let errorBag = [];
                        _.each(response.data.errors, (error) => {
                            if (_.isArray(error)) {
                                errorBag = errorBag.concat(error);
                                return true;
                            }
                            errorBag.push(error);
                        });

                        vi.errorBag = errorBag;
                    })
                    .finally(() => {
                        vi.loading = false;
                    })
            }, 1000)
        }
    },
};
</script>

<style>
.loading-container {
    position: relative;
}

.loading-modal {
    position: absolute;
    top: 0;
    left: 0;
    text-align: center;
    background-color: rgba(0, 0, 0, 0.8);
}
</style>
