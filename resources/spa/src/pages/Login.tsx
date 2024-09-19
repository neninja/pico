import { Button } from '../components/Button';
import { TextInput } from '../components/TextInput';
import React, { useState } from 'react';

export function Login() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');

    const handleSubmit = async (event: React.FormEvent) => {
        event.preventDefault();
        setError('');

        try {
            const response = await fetch('https://api.example.com/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email, password }),
            });

            if (!response.ok) {
                throw new Error('Login failed');
            }

            const data = await response.json();
            localStorage.setItem('token', data.token);
            // Redirecionar ou atualizar o estado da aplicação conforme necessário
        } catch (err) {
            setError('Invalid email or password');
        }
    };

    return (
        <div className="flex justify-center p-4">
            <div className="p-8 sm:p-0 max-w-3xl w-full">
                <h1>Login</h1>
                <form onSubmit={handleSubmit}>
                    <TextInput
                        label="Email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        required/>
                    <TextInput
                        label="Password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        type="password"
                        required/>
                    {error && <p style={{ color: 'red' }}>{error}</p>}
                    <Button type="submit">Login</Button>
                </form>
            </div>
        </div>
    );
}
