import axios from 'axios';
import React, { useState } from 'react';
import { useHistory } from 'react-router-dom';

function Add(props) {
    const [name, setName] = useState('');
    const [position, setPosition] = useState('');
    const history = useHistory();

    const handleName = (e) => {
        setName(e.target.value)
    }
    const handlePosition = (e) => {
        setPosition(e.target.value)
    }
    const handleAdd = () => {
        const data = {
            name: name,
            position: position
        }
        console.log(data)
        axios.post('http://127.0.0.1:8000/api/shelves/store', data)
        .then(response => {
            console.log('Added Successfully', response);
            history.push('/');
        }).catch(error => {
            console.log('Wrong some where', error)
        })
    }


    return (
        <div>
            <h1>Add</h1>
            <form>
                <div className='mb-3'>
                    <label>Name</label>
                    <input
                        type='string'
                        className='form-control'
                        id='name'
                        placeholder='Name Shelves'
                        value={name}
                        required
                    />
                </div>
                <div className='mb-3'>
                    <label>Position</label>
                    <input
                        type='string'
                        classPosition='form-control'
                        id='position'
                        placeholder='Position Shelves'
                        value={position}
                        required
                    />
                </div>
            </form>
        </div>
    );
}

export default Add;