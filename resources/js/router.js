import { createWebHistory, createRouter } from 'vue-router';

import Profile from './views/Profile.vue'
import Students from './views/Students.vue'
import Student from './views/Student/Student.vue'
import Comments from './views/Student/Comments.vue'
import Commented from './views/Student/Commented.vue'

const routes = [
    {
        path: '/students',
        name: 'students',
        component: Students,
    },
    {
        path: '/student/:uniLogin',
        name: 'student',
        component: Student,
        children: [
            {
                name: '/student/:uniLogin/comments',
                path: 'comments',
                component: Comments,
            },
            {
                name: '/student/:uniLogin/commented',
                path: 'commented',
                component: Commented,
            },
        ],
    },
    {
        path: '/profile',
        name: 'profile',
        component: Profile
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});
export { routes };
export default router;