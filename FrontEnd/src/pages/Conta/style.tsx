import { shade } from 'polished';
import styled, { css } from 'styled-components';

interface TransacaoProps{
  entrada: boolean;
}

interface ContaInfoProps{
  status?: string | boolean;
}

export const Header = styled.header`
  display: flex;
  align-items: center;
  justify-content: space-between;

  a {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #3d3d4d;
    transition: color 0.3;

    &:hover {
      color: #666;
    }

    svg {
      margin-right: 4px;
    }
  }
`;

export const ContaInfo = styled.section<ContaInfoProps>`
  margin: 80px 0;

  header {
    display: flex;
    align-items: center;

    img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
    }

    div {
      margin-left: 24px;

      strong {
        font-size: 36px;
        color: #3d3d4d;
      }

      p {
        font-size: 18px;
        color: #737380;
        margin-top: 4px;
      }
    }
  }

  ul {
    display: flex;
    list-style: none;
    margin-top: 40px;
    align-items: center;

    li {
      display: flex;
      flex-direction: column;
      align-items: center;

      & + li {
        margin-left: 80px;
      }

      strong {
        display: block;
        font-size: 36px;
        color: #3d3d4d;
      }

      p {
        display: block;
        margin-top: 4px;
        color: #6c6c80;
        font-size: 18px;
        font-weight: 300;
      }

      button{
        cursor: pointer;
        border: none;
        border-radius: 8px;
        padding: 8px;
        font-size: 20px;
        font-weight: 400;

        ${(props) => props.status ? css`
          color: #f0f0f5;
          background: #c53030;
          transition: 0.3s;

          &:hover{
            background: ${shade(0.2, '#c53030')}
          }
        ` :
        css`
          color: #f0f0f5;
          background: #04d361;
          transition: 0.3s;

          &:hover{
            background: ${shade(0.2, '#04d361')}
          }
        `}


      }
    }
  }
`;

export const Transacao = styled.div<TransacaoProps>`
  background: #fff;
  border-radius: 8px;
  width: 100%;
  padding: 24px;
  display: flex;
  justify-content: space-between;
  text-decoration: none;

  display: flex;
  align-items: center;
  transition: transform 0.2s;

  & + div {
    margin-top: 16px;
  }

  &:hover {
    transform: translateX(10px);
  }

  strong {
    font-size: 20px;

    ${(props) => props.entrada ? css`
      color: #04d361;
    ` : css`
      color: #c53030;
    `}


  }

  p {
    font-size: 18px;
    color: #a8a8b3;
  }
`;
