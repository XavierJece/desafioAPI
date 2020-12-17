import React, { useCallback, useEffect, useState } from 'react';
import { FiChevronLeft } from 'react-icons/fi';
import { Link, useRouteMatch } from 'react-router-dom';
import Logo from '../../components/Logo';
import api from '../../services/api';
import { ContaInfo, Header, Transacao } from './style';

interface ContaParams {
  conta: string;
}

const typeContaAllowed = {
  "10": "CORRENTE",
  "13": "POUPANÇA",
  "25": "MEI",
  "17": "UNIVERSITÁRIO",
};

interface Pessoa{
  nome: string;
}

interface Conta {
  idConta: string;
  saldo: string;
  limiteSaqueDiario: string;
  tipoConta:  keyof typeof typeContaAllowed;
  flagAtivo: boolean;
  pessoa: Pessoa;
}


interface Transacao {
  id: number;
  valor: string;
  dataTransacao: string;
}

const Conta: React.FC = () => {
  const [conta, setConta] = useState<Conta | null>(null);
  const [transacoes, setTransacoes] = useState<Transacao[]>([]);
  const { params } = useRouteMatch<ContaParams>();

  useEffect(() => {
    api.get<Conta>(`/conta/${params.conta}`).then((response) => {
      console.log(response.data);
      setConta(response.data);


    api.get<Transacao[]>(`/conta/${params.conta}/transacoes`).then((response) => {
      console.log(response.data);
      setTransacoes(response.data);
    });


    }).catch(() => {
      setConta(null);
    });
  }, [params.conta]);

  const handleStatus = useCallback((currentStatus: boolean) => {
    if (currentStatus){
      api.patch(`/conta/${params.conta}/desativar`).then((response) => {
        setConta((oldState) => {
          if (!oldState){
            return null;
          }
          return {...oldState, flagAtivo: false};
        });
      });
    }else{
      api.patch(`/conta/${params.conta}/ativar`).then((response) => {
        setConta((oldState) => {
          if (!oldState){
            return null;
          }
          return {...oldState, flagAtivo: true};
        });
      });
    }
  },[]);

  return (
    <>
      <Header>
        <Logo />
        <Link to="/">
          <FiChevronLeft size={16} />
          Voltar
        </Link>
      </Header>

      {conta && (
        <ContaInfo status={conta.flagAtivo}>
          <header>
            <img
              src="https://images.pexels.com/photos/4386433/pexels-photo-4386433.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
              alt="Capa conta"
            />
            <div>
              <strong>{conta.pessoa.nome}</strong>
              <p>{ typeContaAllowed[conta.tipoConta] }</p>
            </div>
          </header>
          <ul>
            <li>
            <strong>{Number(conta.saldo).toLocaleString("pt-BR", { minimumFractionDigits: 2 , style: 'currency', currency: 'BRL' })}</strong>
              <p>Saldo</p>
            </li>
            <li>
            <strong>{Number(conta.limiteSaqueDiario).toLocaleString("pt-BR", { minimumFractionDigits: 2 , style: 'currency' , currency: 'BRL' })}</strong>
              <p>Limite Saque Diário</p>
            </li>
            <li>
              {conta.flagAtivo ? <strong>Ativada</strong> : <strong>Desativada</strong>}
              <p>Status</p>
            </li>
            <li>
              {conta.flagAtivo ?(
                <button type="button" onClick={() => handleStatus(true)} >Desativar</button>
              ):(
                <button type="button" onClick={() => handleStatus(false)}>Ativar</button>
              )}
            </li>
          </ul>
        </ContaInfo>
      )}

      {transacoes && transacoes.map((transacao, i) => (
        <Transacao key={i} entrada={Number(transacao.valor) > 0}>
          <strong>{Number(transacao.valor).toLocaleString("pt-BR", { minimumFractionDigits: 2 , style: 'currency', currency: 'BRL' })}</strong>
          <p>{transacao.dataTransacao}</p>
        </Transacao>
      ))}
    </>
  );
};

export default Conta;
