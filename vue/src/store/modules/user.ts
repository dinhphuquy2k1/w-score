// myStore.ts
import {createStore} from 'vuex';
import {handleServerError, handleSuccess, handleWarning, handleError} from "@/main";

export default {
    state: {
        token: null,
    },
    mutations: {
        // Định nghĩa mutations nếu cần thiết
        SET_TOKEN(state: any, token: any) {
            state.token = token;
        }
    },
    actions: {
        setToken({ commit }: { commit: Function }, token: any) {
            console.log(token)
            commit('SET_TOKEN', token)
        },
        checkToken(context: any) {
            return context.getters.getToken
        }
    },
    getters: {
        getToken(state: any) {
            return state.token;
        },
    }
};
