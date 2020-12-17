import React, { FormEvent, useCallback, useEffect, useState } from 'react';
import { FiChevronLeft, FiFrown } from 'react-icons/fi';
import { Link, useHistory, useRouteMatch } from 'react-router-dom';
import Logo from '../../components/Logo';
import api from '../../services/api';
import { ContaInfo, Header, Transacao, Form, Error } from './style';

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

interface FilterDate {
  initial: string;
  final: string;
}

const Conta: React.FC = () => {
  const { params } = useRouteMatch<ContaParams>();
  const [inputError, setInputError] = useState('');
  const [filterDate, setFilterDate] = useState<FilterDate>({ initial: "", final: ""});
  const [conta, setConta] = useState<Conta | null>(null);
  const [transacoes, setTransacoes] = useState<Transacao[]>([]);
  const history = useHistory();

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

  const handleFilter = useCallback((event: FormEvent<HTMLFormElement>) => {
    event.preventDefault();

    const param1 = filterDate.initial.length !== 0 ? `dateInitial=${filterDate.initial}`: "";
    const param2 = filterDate.final.length !== 0 ? `dateFinal=${filterDate.final}`: "";


    let query = '';
    if(param1.length !== 0 && param2.length !== 0){
      query = `?${param1}&${param2}`;
    }else if(param1.length === 0 && param2.length !== 0){
      query = `?${param2}`;
    }else if(param1.length !== 0 && param2.length === 0){
      query = `?${param1}`;
    }else{
      query = ``;
    }

    api.get<Transacao[]>(`/conta/${params.conta}/transacoes${query}`).then((response) => {
      console.log(response.data);
      setTransacoes(response.data);
    });

  },[params.conta, filterDate]);

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

      <Form onSubmit={handleFilter}>
        <h2>Extrato</h2>
        <div>
          <div>
            <div>
              <span>Data Inicial</span>
              <input
                value={filterDate.initial}
                onChange={(e) => setFilterDate({...filterDate, initial: e.target.value})}
                placeholder="10/07/2003"
                type="date"
                />
            </div>
            <div>
              <span>Data Final</span>
              <input
                value={filterDate.final}
                onChange={(e) => setFilterDate({...filterDate, final: e.target.value})}
                placeholder="17/12/2020"
                type="date"
              />
            </div>
          </div>
          <button type="submit">Filtrar</button>
          </div>
        {inputError && (
          <Error>
            <span>{inputError}</span>
            <FiFrown size={20} />
          </Error>
        )}
      </Form>

      {transacoes.map((transacao, i) => (
        <Transacao key={i} entrada={Number(transacao.valor) > 0}>
          <strong>{Number(transacao.valor).toLocaleString("pt-BR", { minimumFractionDigits: 2 , style: 'currency', currency: 'BRL' })}</strong>
          <p>{transacao.dataTransacao}</p>
        </Transacao>
      ))}
      {transacoes.length === 0 && (
         <strong>Nenhuma movimentação neste período</strong>
      )}
    </>
  );
};

export default Conta;
