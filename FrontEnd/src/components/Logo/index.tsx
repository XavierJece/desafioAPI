import React from 'react';
import { GiReceiveMoney } from 'react-icons/gi';


import { Container } from './styles';

const Logo: React.FC = () => {
  return (
    <Container>
      <GiReceiveMoney size={32}/>
      MEU BANCO
    </Container>
  );
}

export default Logo;
