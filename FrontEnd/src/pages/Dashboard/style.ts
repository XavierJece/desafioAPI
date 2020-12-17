import styled, { css } from 'styled-components';
import { shade, transparentize } from 'polished';

import { Link as LinkReact } from 'react-router-dom';

interface LinkProps{
  status?: string | boolean;
}

interface FormProps {
  hasError: boolean;
}

export const Title = styled.h1`
  font-size: 48px;
  color: #3a3a3a;
  max-width: 450px;
  line-height: 56px;

  margin-top: 80px;
`;

export const Form = styled.form<FormProps>`
  margin-top: 40px;
  max-width: 700px;

  display: flex;

  input {
    flex: 1;
    height: 70px;
    padding: 0 24px;
    border: 2px solid #fff;
    border-radius: 5px 0 0 5px;
    color: #3a3a3a;
    border-right: 0;

    ${(props) =>
      props.hasError &&
      css`
        border-color: #c53030;
        background: ${transparentize(0.95, '#c53030')};
      `}

    &::placeholder {
      color: #a8a8b3;
    }
  }

  button {
    width: 210px;
    height: 70px;
    background: #04d361;
    border-radius: 0 5px 5px 0;
    border: 2px solid #04d361;
    border-left: 0;
    color: #fff;
    font-weight: bold;
    transition: background-color 0.2s;

    ${(props) =>
      props.hasError &&
      css`
        border-color: #c53030;
      `}

    &::placeholder {
      color: #a8a8b3;
    }

    &:hover {
      background: ${shade(0.2, '#04d361')};
    }
  }
`;

export const Contas = styled.div`
  margin-top: 80px;
  max-width: 700px;
`;

export const Error = styled.div`
  display: flex;
  color: #c53030;
  margin-top: 8px;
  align-items: center;
  svg {
    margin-left: 8px;
  }
`;


export const Link = styled(LinkReact)<LinkProps>`
  background: #fff;

  border-radius: 8px;
  width: 100%;
  padding: 24px;
  display: block;
  text-decoration: none;

  display: flex;
  align-items: center;
  transition: transform 0.2s;

  & + a {
    margin-top: 16px;
  }

  ${(props) => !props.status && css`
    background: #f0f0f5;
  `}

  &:hover {
    transform: translateX(10px);
  }

  > span{
    min-width: 44px;
    min-height: 44px;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;

    padding: 4px;
    border-radius: 50%;
    color: #fff;
    background-color: #3d3d4d;
    font-size: 18px;
  }

  p {
    font-size: 18px;
    color: #a8a8b3;
  }

  div {
    margin: 0 16px;
    flex: 1;
    text-align: center;

    strong {
      font-size: 20px;
      color: #3d3d4d;
    }
  }

  svg {
    margin-left: auto;
    color: #cbcbd6;
  }
`;