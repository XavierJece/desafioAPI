import React, { useEffect, useState } from 'react';
import { FiChevronRight } from 'react-icons/fi';
import Logo from '../../components/Logo';
import api from '../../services/api';
import { Contas, Link, Title } from './style';

const typeContaAllowed = {
  "10": "CORRENTE",
  "13": "POUPANÇA",
  "25": "MEI",
  "17": "UNIVERSITÁRIO",
};

interface Conta {
  idConta: string;
  saldo: string;
  flagAtivo: string;
  tipoConta:  keyof typeof typeContaAllowed;
  dataCriacao: string;
}

const Dashboard: React.FC = () => {
  const [contas, setContas] = useState<Conta[]>([]);

  useEffect(() => {
    api
    .get<Conta[]>(`/conta`)
    .then(response => {
      setContas(response.data);
    });
  }, []);

  return (
    <>
      <Logo/>
      <Title>Contas <br/> Meu Banco</Title>

      <Contas>
        {contas.map((conta) => (
          <Link
            status={conta.flagAtivo === "1"}
            key={conta.idConta}
            to={`/conta/${conta.idConta}`}
          >
            <span>
              {conta.idConta}
            </span>
            <div>
              <strong>{typeContaAllowed[conta.tipoConta]}</strong>
              { conta.flagAtivo === "1" ? <p>Ativada</p> : <p>Desativada</p>}
            </div>
            <p>{Number(conta.saldo).toLocaleString("pt-BR", { minimumFractionDigits: 2 , style: 'currency', currency: 'BRL' })}</p>
            <FiChevronRight size={20} />
          </Link>
        ))}
      </Contas>
    </>
  );
};

export default Dashboard;
