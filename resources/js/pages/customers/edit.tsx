import { Head, useForm } from '@inertiajs/react';

interface Customer {
    id: number;
    name: string;
    email: string;
    gender: string;
    phone_number: string;
}

interface Props {
    customer: Customer;
}

export default function Edit({ customer }: Props) {
    const { data, setData, put, processing, errors } = useForm({
        name: customer.name,
        email: customer.email,
        gender: customer.gender,
        phone_number: customer.phone_number,
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(`/customers/${customer.id}`);
    };

    return (
        <>
            <Head title="Edit Customer" />
            <div className="mx-auto max-w-md p-6">
                <h1 className="mb-4 text-xl font-semibold">Edit Customer</h1>
                <form onSubmit={handleSubmit} className="space-y-4">
                    <div>
                        <label className="mb-1 block">Name</label>
                        <input
                            type="text"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            className="w-full rounded border border-gray-300 p-2"
                        />
                        {errors.name && <p className="text-sm text-red-600">{errors.name}</p>}
                    </div>

                    <div>
                        <label className="mb-1 block">Email</label>
                        <input
                            type="email"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                            className="w-full rounded border border-gray-300 p-2"
                        />
                        {errors.email && <p className="text-sm text-red-600">{errors.email}</p>}
                    </div>

                    <div>
                        <label className="mb-1 block">Gender</label>
                        <select
                            value={data.gender}
                            onChange={(e) => setData('gender', e.target.value)}
                            className="w-full rounded border border-gray-300 p-2"
                        >
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        {errors.gender && <p className="text-sm text-red-600">{errors.gender}</p>}
                    </div>

                    <div>
                        <label className="mb-1 block">Phone Number</label>
                        <input
                            type="text"
                            value={data.phone_number}
                            onChange={(e) => setData('phone_number', e.target.value)}
                            className="w-full rounded border border-gray-300 p-2"
                        />
                        {errors.phone_number && <p className="text-sm text-red-600">{errors.phone_number}</p>}
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        className="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                    >
                        Update
                    </button>
                </form>
            </div>
        </>
    );
}
