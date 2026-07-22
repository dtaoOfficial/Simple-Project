import { Head, Link, router } from '@inertiajs/react';

interface Customer {
    id: number;
    name: string;
    email: string;
    gender: string;
    phone_number: string;
}

interface Props {
    customers: Customer[];
}

export default function Index({ customers }: Props) {
    const handleDelete = (id: number) => {
        if (confirm('Are you sure you want to delete this customer?')) {
            router.delete(`/customers/${id}`);
        }
    };

    return (
        <>
            <Head title="Customers" />
            <div className="p-6">
                <div className="mb-4 flex items-center justify-between">
                    <h1 className="text-xl font-semibold">Customers</h1>
                    <Link
                        href="/customers/create"
                        className="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                    >
                        + Add Customer
                    </Link>
                </div>

                <table className="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr className="bg-gray-100">
                            <th className="border border-gray-300 p-2 text-left">Name</th>
                            <th className="border border-gray-300 p-2 text-left">Email</th>
                            <th className="border border-gray-300 p-2 text-left">Gender</th>
                            <th className="border border-gray-300 p-2 text-left">Phone</th>
                            <th className="border border-gray-300 p-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {customers.map((customer) => (
                            <tr key={customer.id}>
                                <td className="border border-gray-300 p-2">{customer.name}</td>
                                <td className="border border-gray-300 p-2">{customer.email}</td>
                                <td className="border border-gray-300 p-2">{customer.gender}</td>
                                <td className="border border-gray-300 p-2">{customer.phone_number}</td>
                                <td className="border border-gray-300 p-2">
                                    <Link
                                        href={`/customers/${customer.id}/edit`}
                                        className="mr-3 text-blue-600 hover:underline"
                                    >
                                        Edit
                                    </Link>
                                    <button
                                        onClick={() => handleDelete(customer.id)}
                                        className="text-red-600 hover:underline"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    );
}
