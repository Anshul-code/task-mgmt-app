import store from "../store";
import router from "../router";

axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
axios.defaults.headers.common['Accept'] = 'application/json;charset=UTF-8';

axios.interceptors.response.use(
    response => response, 
    error => {
    if(error.response.status == 401) { // When Unauthorized logout and redirect to Login Page
        console.log('Interceptor 401');
        store.dispatch('removeBToken');
        store.dispatch('removeUser');
        
        router.push({name: 'Login'});
    } else {
        return Promise.reject(error);
    }
});

