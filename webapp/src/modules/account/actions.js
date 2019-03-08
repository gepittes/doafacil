import * as jwtDecode from 'jwt-decode';
import * as jwt from 'jsonwebtoken';
import { userService } from '../user/service';
import * as types from './types';
import router from '../../router';

export const login = ({ dispatch, commit }, { email, password }) => {
    commit(types.LOGINREQUEST, { email });

    return userService.login(email, password)
        .then((response) => {
            if (response.data && response.data.data) {
                const { data } = response.data;
                if (data && data.token) {
                    localStorage.setItem('user', JSON.stringify(data.token));
                    commit(types.LOGINSUCCESS, data);
                    dispatch('alert/info', 'Login realizado com sucesso!', {
                        root: true,
                    });
                    const token = JSON.stringify(data.token);
                    
                    try {
                        console.log('---====---');
                        console.log(process.env.VUE_APP_JWT_SECRET)
                        const objJWT = jwt.verify(token, process.env.VUE_APP_JWT_SECRET);
                        console.log(objJWT);
                        return false;
                    } catch (Exception) {
                        console.log('<<<<');
                        console.log(Exception);
                        return false;
                    }

                    const tokenDecodificada = jwtDecode(token);
                    commit(types.SETACCOUNTINFO, tokenDecodificada.user);

                    router.push({ name: 'home' });
                } else {
                    dispatch('alert/error', 'Falha ao realizar login.', {
                        root: true,
                    });
                }
            }
        })
        .catch((error) => {
            if (error.response && error.response.data) {
                commit(types.LOGINFAILURE, error.response.data.error);
                dispatch('alert/error', error.response.data.error, {
                    root: true,
                });
            }
        });
};

export const logout = ({ commit }) => {
    userService.logout();
    commit(types.LOGOUT);
};

export const register = ({ dispatch, commit }, user) => {
    commit(types.REGISTERREQUEST);
    userService.register(user)
        .then(
            () => {
                commit(types.REGISTERSUCCESS);
                dispatch('alert/success', 'Cadastro realizado com sucesso!', { root: true });
                router.push('/login');
            },
            (error) => {
                if (error.response && error.response.data) {
                    commit(types.REGISTERFAILURE);
                    dispatch('alert/error', error.response.data.error, {
                        root: true,
                    });
                }
            },
        );
};
