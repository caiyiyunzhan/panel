import React, { useState } from 'react';
import EditSubuserModal from '@/components/server/users/EditSubuserModal';
import { Button } from '@/components/elements/button/index';
import { useTranslation } from "react-i18next";

export default () => {
    const { t } = useTranslation("server");
    const [visible, setVisible] = useState(false);

    return (
        <>
            <EditSubuserModal visible={visible} onModalDismissed={() => setVisible(false)} />
            <Button onClick={() => setVisible(true)}>New User</Button>
        </>
    );
};
