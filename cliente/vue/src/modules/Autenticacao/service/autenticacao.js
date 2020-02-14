import * as service from '../../shared/service/base/index';

export const login = usuario => service.postRequest('/auth/login', usuario);

export const logout = usuario => service.postRequest('/auth/logout', usuario);

export const recuperarSenha = usuario => service.postRequest('/auth/recuperar-senha', usuario);
