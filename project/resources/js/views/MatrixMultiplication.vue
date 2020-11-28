<template>
    <div>
        <div class="mt-5 container-lg container-md">
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
        }
    },
    methods: {
        updateMatrices(name, value) {
            this.matrices[name] = value;
        },
        validate() {
            // check if we can do the calculation?
        },
        async calculate() {
            console.log('send request...');
            this.errorBag = this.resultMatrix = [];
            let data = this.matrices;
            // `vue instance`
            let vi = this;
            await axios
                .post('http://localhost/api/v1/matrix/multiply', data)
                .then(({data}) => {
                    console.log(data);
                    console.log(typeof data);
                    vi.resultMatrix = data.data
                })
                .catch(({response}) => {
                    let errorBag = [];
                    console.log(response.data);
                    _.each(response.data.errors, (error) => {
                        if (_.isArray(error)) {
                            errorBag = errorBag.concat(error);
                            return true;
                        }
                        errorBag.push(error);
                    });

                    vi.errorBag = errorBag;
                })
        }
    },
};
</script>
