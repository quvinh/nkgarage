import axios from 'axios';
import React, { useState } from 'react';
import {useHistory} from 'react-router-dom'

function Add(props) {
    const [name, setName] = useState('');
    const [location, setLocation] = useState('');
    const [note, setNote] = useState('');
    const history = useHistory()

    const handleName = (e) => {
        setName(e.target.value)
    }
    const handleLocation = (e) => {
        setLocation(e.target.value)
    }
    const handleNote = (e) => {
        setNote(e.target.value)
    }
    const handleAdd = () => {
        const data = {
            name: name,
            location: location,
            note: note
        }
        console.log(data);
        axios.post('http://127.0.0.1:8000/api/store', data)
        .then(resopnse => {
            console.log('Added Successfully', resopnse)
            history.push('/')
        }).catch(error => {
            console.log(error)
        })
    }

    return (
        <div>
            <h2>Add</h2>
            <br/>
            <form>
                <div className='mb-3'>
                    <label>Name</label>
                    <input 
                        type='string'
                        className='form-control'
                        id='name'
                        placeholder='Name Warehouse'
                        value={name}
                        onChange={handleName} 
                    />
                </div>
                <div className='mb-3'>
                    <label>Location</label>
                    <input 
                        type='string'
                        classLocation='form-control'
                        id='location'
                        placeholder='Location Warehouse'
                        value={location}
                        onChange={handleLocation} 
                    />
                </div>
                <div className='mb-3'>
                    <label>Note</label>
                    <input 
                        type='string'
                        classNote='form-control'
                        id='note'
                        placeholder='Note Warehouse'
                        value={note}
                        onChange={handleNote} 
                    />
                </div>
            </form>
        </div>
    );
}

export default Add;