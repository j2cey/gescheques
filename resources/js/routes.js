import VueRouter from 'vue-router';


let routes = [
    {
        name: 'dashboard',
        path: '/dashboard',
        component: require('./views/dashboard').default
    },
    {
        name: 'users.index',
        path: '/users',
        component: require('./views/users/index').default
    },
    {
        name: 'roles.index',
        path: '/roles',
        component: require('./views/roles/index').default
    },
    {
        name: 'bordereauremises.index',
        path: '/bordereauremises',
        component: require('./views/bordereauremises/index').default
    },
    {
        name: 'workflows.index',
        path: '/workflows',
        component: require('./views/workflows/workflows').default
    }
];

export default new VueRouter({
    base: '/',
    mode: 'history',
    routes,
    linkActiveClass: 'active'
});
