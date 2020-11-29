<template>
    <div class="matrix-multiplication">
        <div class="mt-5 container-lg container-md loading-container">
            <div class="row">
                <h1>Matrix Multiplier</h1>
            </div>
            <div class="row">
                <div class="col-sm col-md mb-2 p-0">
                    <MatrixInput @matricesUpdated="updateMatrices" name="first matrix"></MatrixInput>
                </div>
                <div class="col-sm col-md mb-2 p-0">
                    <MatrixInput @matricesUpdated="updateMatrices" name="second_matrix"></MatrixInput>
                </div>
            </div>
            <div class="row">
                <button @click="calculate" class="btn btn-primary btn-block">Multiply Matrices</button>
            </div>
            <div class="row mt-5">
                <div v-if="messageBag.length" class="col-md-6 col-sm-12">
                    <div v-for="message in messageBag"
                         :class="['alert', `alert-${messageType}`, 'alert-dismissible', 'fade', 'show']">
                        {{ message }}
                    </div>
                </div>
                <div v-if="resultMatrix.length" class="col-md-6 col-sm-12">
                    <Matrix :matrix="resultMatrix" name="result matrix"/>
                </div>
            </div>
            <Loading :loading="loading" color="warning"/>
        </div>
    </div>
</template>

<script>
import MatrixInput from '../components/MatrixInput';
import Matrix from "../components/Matrix";
import Loading from "../components/Loading";

export default {
    components: {
        MatrixInput,
        Matrix,
        Loading,
    },
    data() {
        return {
            matrices: {},
            columnSize: 6,
            resultMatrix: [],
            messageBag: [],
            messageType: 'danger',
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

            this.messageBag = this.resultMatrix = [];
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
                        vi.messageType = 'success';
                        vi.messageBag.push('Calculation done successfully.');
                    })
                    .catch(({response}) => {
                        let errorBag = [];
                        vi.messageType = 'danger';
                        _.each(response.data.errors, (error) => {
                            if (_.isArray(error)) {
                                errorBag = errorBag.concat(error);
                                return true;
                            }
                            errorBag.push(error);
                        });

                        vi.messageBag = errorBag;
                    })
                    .finally(() => {
                        vi.loading = false;
                    })
            }, 1000)
        }
    },
};
</script>
