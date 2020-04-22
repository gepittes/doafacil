import axios from 'axios';

const TOKEN = '1dd1ab4c82cd0773c29ac61303122fb4';

export const cepAberto = axios.create({
  baseURL: 'http://www.cepaberto.com/api/v3/cep?cep=40010000',
  headers: {
    Authorization: `Token token="${TOKEN}"`
  }
});
