import { Head, Link, router } from '@inertiajs/react';

interface Programme {
    id: number;
    name: string;
    description: string;
    schedule: string;
    activities: string;
    outcomes: string;
}

interface Props {
    programmes: Programme[];
}

export default function Index({ programmes }: Props) {
    const handleDelete = (id: number) => {
        if (confirm('Are you sure you want to delete this programme?')) {
            router.delete(`/programmes/${id}`);
        }
    };

    return (
        <>
            <Head title="Programmes" />
            <div className="p-6">
                <div className="mb-4 flex items-center justify-between">
                    <h1 className="text-xl font-semibold">Programmes</h1>
                    <Link
                        href="/programmes/create"
                        className="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                    >
                        + Add Programme
                    </Link>
                </div>

                <table className="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr className="bg-gray-100">
                            <th className="border border-gray-300 p-2 text-left">Name</th>
                            <th className="border border-gray-300 p-2 text-left">Schedule</th>
                            <th className="border border-gray-300 p-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {programmes.map((programme) => (
                            <tr key={programme.id}>
                                <td className="border border-gray-300 p-2">{programme.name}</td>
                                <td className="border border-gray-300 p-2">{programme.schedule}</td>
                                <td className="border border-gray-300 p-2">
                                    <Link
                                        href={`/programmes/${programme.id}/edit`}
                                        className="mr-3 text-blue-600 hover:underline"
                                    >
                                        Edit
                                    </Link>
                                    <button
                                        onClick={() => handleDelete(programme.id)}
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
