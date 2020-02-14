const isCpfValido = (strCPF) => {
  if (!strCPF) {
    return false;
  }

  let soma;
  let resto;
  soma = 0;

  const BLACKLIST = [
    '00000000000',
    '11111111111',
    '22222222222',
    '33333333333',
    '44444444444',
    '55555555555',
    '66666666666',
    '77777777777',
    '88888888888',
    '99999999999',
  ];

  /* eslint-disable no-param-reassign */
  strCPF = strCPF.replace(/[^\d]+/g, '');

  if (BLACKLIST.includes(strCPF)) return false;

  for (let i = 1; i <= 9; i += 1) soma += parseInt(strCPF.substring(i - 1, i), 10) * (11 - i);
  resto = (soma * 10) % 11;
  if ((resto === 10) || (resto === 11)) resto = 0;
  if (resto !== parseInt(strCPF.substring(9, 10), 10)) return false;
  soma = 0;
  for (let i = 1; i <= 10; i += 1) soma += parseInt(strCPF.substring(i - 1, i), 10) * (12 - i);
  resto = (soma * 10) % 11;
  if ((resto === 10) || (resto === 11)) resto = 0;
  if (resto !== parseInt(strCPF.substring(10, 11), 10)) return false;
  return true;
};

const isCnpjValido = (strCnpj) => {
  const stripped = strCnpj.replace(/[^\d]+/g, '');

  if (stripped === '') return false;

  if (stripped.length !== 14) return false;

  const BLACKLIST = [
    '00000000000000',
    '11111111111111',
    '22222222222222',
    '33333333333333',
    '44444444444444',
    '55555555555555',
    '66666666666666',
    '77777777777777',
    '88888888888888',
    '99999999999999',
  ];

  if (BLACKLIST.includes(stripped)) return false;

  let tamanho = stripped.length - 2;
  let numeros = stripped.substring(0, tamanho);
  const digitos = stripped.substring(tamanho);

  let soma = 0;
  let pos = tamanho - 7;

  for (let i = tamanho; i >= 1; i -= 1) {
    /* eslint-disable no-plusplus */
    soma += numeros.charAt(tamanho - i) * pos--;
    if (pos < 2) pos = 9;
  }

  /* eslint-disable no-mixed-operators */
  let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
  if (parseInt(resultado, 10) !== parseInt(digitos.charAt(0), 10)) return false;

  tamanho += 1;

  numeros = stripped.substring(0, tamanho);
  soma = 0;
  pos = tamanho - 7;

  for (let y = tamanho; y >= 1; y -= 1) {
    soma += numeros.charAt(tamanho - y) * pos--;
    if (pos < 2) pos = 9;
  }
  resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

  return parseInt(resultado, 10) === parseInt(digitos.charAt(1), 10);
};

const isEmailValido = (strEmail) => {
  /* eslint-disable no-useless-escape, max-len */
  const regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/;
  return regex.test(strEmail);
};

const isSenhaValida = (strSenha) => {
  const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
  return regex.test(strSenha);
};

const isDataValida = (dateString) => {
  if (!dateString) {
    return true;
  }

  if (dateString.includes('/')) {
    const [dia, mes, ano] = dateString.split('/');
    /* eslint-disable no-param-reassign */
    dateString = `${ano}-${mes}-${dia}`;
  }

  // First check for the pattern
  const regexDate = /^\d{4}\-\d{1,2}\-\d{1,2}$/;

  if (!regexDate.test(dateString)) {
    return false;
  }

  // Parse the date parts to integers
  const parts = dateString.split('-');
  const day = parseInt(parts[2], 10);
  const month = parseInt(parts[1], 10);
  const year = parseInt(parts[0], 10);

  // Check the ranges of month and year
  if (year < 1000 || year > 3000 || month === 0 || month > 12) {
    return false;
  }

  const monthLength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

  // Adjust for leap years
  if (year % 400 === 0 || (year % 100 !== 0 && year % 4 === 0)) {
    monthLength[1] = 29;
  }

  // Check the range of the day
  return day > 0 && day <= monthLength[month - 1];
};

const isCepValido = (cep) => {
  const validacep = /^[0-9]{8}$/;
  return validacep.test(cep.replace(/[^\d]+/g, ''));
};

export default {
  isCnpjValido,
  isCpfValido,
  isEmailValido,
  isSenhaValida,
  isDataValida,
  isCepValido,
};
