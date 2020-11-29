import Vue from 'vue';
import VueRouter from 'vue-router';

/** Views **/
import MatrixMultiplication from "./views/MatrixMultiplication";
import PageNotFound from "./views/PageNotFound";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', component: MatrixMultiplication },
        { path: "*", component: PageNotFound }
    ],
    mode: 'history',
});
