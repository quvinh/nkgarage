import React, { useState } from 'react';
import { useHistory } from 'react-router-dom';
import isEmpty from 'validator/lib/isEmpty';
import axios from 'axios';
import { login } from './data/Api';

function Login(props) {
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [validationMsg, setValidationMsg] = useState('');
    const history = useHistory();

    const handleUsername = (e) => {
        setUsername(e.target.value)
    }
    const handlePassword = (e) => {
        setPassword(e.target.value)
    }
    const handleLogin = () => {
        const data = {
            username: username,
            password: password
        }
        console.log(data);
        axios.post(login, data)
            .then(res => {
                console.log('Login successfully');
            }).catch(error => {
                const isValid = validatorAll();
                console.log(isValid);
                // console.log(error);
            })
    }

    const validatorAll = () => {
        const msg = {}
        if(isEmpty(username)) {
            msg.username = 'Please input your username'
        }

        if(isEmpty(password)) {
            msg.password = 'Input your password'
        }

        setValidationMsg(msg)
        if(Object.keys(msg).length > 0) return false
        return true
    }

    return (
        <div className='card'>
            <div className='card-body'>
                <form>
                    <div className="mb-3">
                        <label className="form-label">Tên đăng nhập</label>
                        <input
                            type="text"
                            className="form-control"
                            id="username"
                            placeholder="Tên đăng nhập"
                            value={username}
                            onChange={handleUsername} />
                    </div>
                    <p className='text-danger'>{validationMsg.username}</p>
                    <div className="mb-3">
                        <label className="form-label">Mật khẩu</label>
                        <input
                            type="password"
                            className="form-control"
                            id="password"
                            placeholder="Mật khẩu"
                            value={password}
                            onChange={handlePassword} />
                    </div>
                    <p className='text-danger'>{validationMsg.password}</p>
                    <button type='button' onClick={handleLogin} className='btn btn-primary' >Đăng nhập</button>
                </form>
            </div>
        </div>
    );
}

export default Login;
