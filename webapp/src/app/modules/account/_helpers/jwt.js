import * as jsonwebtoken from "jsonwebtoken";

export function obterInformacoesJWT() {

    // eslint-disable-next-line no-undef
    if (process.env.VUE_APP_JWT_SECRET == null) {
      const error =
        "Variável de ambiente `VUE_APP_JWT_SECRET` não definida no arquivo `.env`.";
      throw error;
    }

    const token = localStorage.getItem("token");
    return token != null
      // eslint-disable-next-line no-undef
      ? jsonwebtoken.verify(token, process.env.VUE_APP_JWT_SECRET)
      : "";
}

export function obterCabecalhoComToken() {
  const token = localStorage.getItem("token");
  if (token) {
    return {
      headers: {
        Authorization: `Bearer ${token}`
      }
    };
  }
  return {};
}
