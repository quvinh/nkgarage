import React, { useState } from 'react';
import { useHistory } from 'react-router-dom';
import isEmpty from 'validator/lib/isEmpty';
import axios from 'axios';
import { register } from './Api';

function Login(props) {
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [password_confirmation, setPasswordConfirmation] = useState('');
    const [email, setEmail] = useState('');
    const [fullname, setFullname] = useState('');
    const [phone, setPhone] = useState('');
    const [birthday, setBirthday] = useState('');
    const [address, setAddress] = useState('');
    const [sex, setSex] = useState('');

    const [validationMsg, setValidationMsg] = useState('');
    const history = useHistory();

    const handleUsername = (e) => {
        setUsername(e.target.value)
    }
    const handlePassword = (e) => {
        setPassword(e.target.value)
    }
    const handleRegister = () => {
        const data = {
            username: username,
            password: password,
            password_confirmation: password_confirmation,
            email: email,
            fullname: fullname,
            phone: phone,
            birthday: birthday,
            address: address,
            sex: sex
        }
        console.log(data);
        axios.post(register, data)
            .then(res => {
                console.log('Register successfully');
            }).catch(error => {
                const isValid = validatorAll();
                console.log(isValid);
                // console.log(error);
            })
    }

    const validatorAll = () => {
        const msg = {}
        if (isEmpty(username)) {
            msg.username = 'Chưa điền tên đăng nhập'
        }
        if (isEmpty(password)) {
            msg.password = 'Chưa điền mật khẩu'
        }
        if (isEmpty(password_confirmation)) {
            msg.password_confirmation = 'Chưa điền lại mật khẩu'
        }
        if (isEmpty(email)) {
            msg.email = 'Chưa điền email'
        }
        if (isEmpty(fullname)) {
            msg.fullname = 'Chưa điền Họ và tên'
        }
        if (isEmpty(phone)) {
            msg.phone = 'Chưa điền số điện thoại'
        }
        if (isEmpty(address)) {
            msg.address = 'Chưa điền địa chỉ'
        }
        if (isEmpty(birthday)) {
            msg.birthday = 'Chưa điền ngày sinh'
        }
        if (isEmpty(sex)) {
            msg.sex = 'Chưa chọn giới tính'
        }

        setValidationMsg(msg)
        if (Object.keys(msg).length > 0) return false
        return true
    }

    return (
        <div className='card'>
            <div className='card-body'>
                <h2 className='card-title'>Đăng ký tài khoản</h2>
                <form>
                    <div className="mb-3">
                        <label className="form-label">Tên đăng nhập</label>
                        <input
                            type="text"
                            className="form-control"
                            id="username"
                            placeholder="Tên đăng nhập"
                            value={username}
                            onChange={(e) => { setUsername(e.target.value) }} />
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
                            onChange={(e) => { setPassword(e.target.value) }} />
                    </div>
                    <p className='text-danger'>{validationMsg.password}</p>
                    <div className="mb-3">
                        <label className="form-label">Nhập lại mật khẩu</label>
                        <input
                            type="password"
                            className="form-control"
                            id="password_confirmation"
                            placeholder="Nhập lại mật khẩu"
                            value={password_confirmation}
                            onChange={(e) => { setPasswordConfirmation(e.target.value) }} />
                    </div>
                    <p className='text-danger'>{validationMsg.password_confirmation}</p>
                    <div className="mb-3">
                        <label className="form-label">Email</label>
                        <input
                            type="email"
                            className="form-control"
                            id="email"
                            placeholder="name@gmail.com"
                            value={email}
                            onChange={(e) => { setEmail(e.target.value) }} />
                    </div>
                    <p className='text-danger'>{validationMsg.email}</p>
                    <div className="mb-3">
                        <label className="form-label">Họ và tên</label>
                        <input
                            type="text"
                            className="form-control"
                            id="fullname"
                            placeholder="Họ và tên"
                            value={fullname}
                            onChange={(e) => { setFullname(e.target.value) }} />
                    </div>
                    <p className='text-danger'>{validationMsg.fullname}</p>
                    <div className="mb-3">
                        <label className="form-label">Số điện thoại</label>
                        <input
                            type="text"
                            className="form-control"
                            id="phone"
                            placeholder="0123456789"
                            value={phone}
                            onChange={(e) => { setPhone(e.target.value) }} />
                    </div>
                    <p className='text-danger'>{validationMsg.phone}</p>
                    <div className="mb-3">
                        <label className="form-label">Ngày sinh</label>
                        <input
                            type="date"
                            className="form-control"
                            id="birthday"
                            placeholder="Ngày sinh"
                            value={birthday}
                            onChange={(e) => { setBirthday(e.target.value) }} />
                    </div>
                    <p className='text-danger'>{validationMsg.birthday}</p>
                    <div className="mb-3">
                        <label className="form-label">Địa chỉ</label>
                        <input
                            type="text"
                            className="form-control"
                            id="address"
                            placeholder="Địa chỉ"
                            value={address}
                            onChange={(e) => { setAddress(e.target.value) }} />
                    </div>
                    <p className='text-danger'>{validationMsg.address}</p>
                    <br />
                    <label className="form-check-label">Giới tính</label>
                    <div className="form-check">
                        <input
                            className="form-check-input"
                            type="radio"
                            name="sex"
                            id="sex1"
                            value="1"
                            onChange={(e) => setSex(e.target.value)} />
                            <label className="form-check-label">Nam</label>
                    </div>
                    <div className="form-check">
                        <input
                            className="form-check-input"
                            type="radio"
                            name="sex"
                            id="sex2"
                            value="0"
                            onChange={(e) => setSex(e.target.value)} />
                            <label className="form-check-label">Nữ</label>
                    </div>
                    <p className='text-danger'>{validationMsg.sex}</p>
                    <br />
                    <button type='button' onClick={handleRegister} className='btn btn-primary' >Đăng kí</button>
                </form>
            </div>
        </div>
    );
}

export default Login;
