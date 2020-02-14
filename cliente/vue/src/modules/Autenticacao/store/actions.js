import * as autenticacaoService from '../service/autenticacao';

/** Autenticação */

export const autenticarUsuario = async ({dispatch}, usuario) => autenticacaoService
  .login(usuario)
  .then((response) => {
    const {data} = response;
    if (data && data.access_token) {
      localStorage.setItem('user_token', data.access_token);
    }

    dispatch(
      'app/setMensagemSucesso',
      'Login efetuado com sucesso!', {root: true},
    );

    return data;
  }).catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'autenticarUsuario', 10);
  });


export const recuperarSenha = async (state, usuario) => autenticacaoService
  .recuperarSenha(usuario);

export const logout = async () => autenticacaoService
  .logout({})
  .then(() => {
    localStorage.clear();
  });
